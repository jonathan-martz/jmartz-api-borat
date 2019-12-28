<?php

use Robo\Tasks;

class RoboFile extends Tasks
{
	public function composerInstall()
	{
		$this->stopOnFail(true);
		$this->taskComposerInstall()
			->workingDir('.')
			->ignorePlatformRequirements()
			->run();

		$this->taskComposerInstall()
			->workingDir('./src')
			->ignorePlatformRequirements()
			->run();
	}

	public function phanCheck()
	{
		$this->stopOnFail(false);
		$filename = 'src/storage/logs/phan.json';
		$this->_exec('vendor/bin/phan -m json -o ' . $filename . ' --dead-code-detection --unused-variable-detection');
		if (file_exists($filename)) {
			$json = file_get_contents($filename);
			$errors = json_decode($json);
			if (count($errors) !== 0) {
				exit("Phan detected some errors take a look at log/phan.json and fix the errors.");
			}
		}
		$this->stopOnFail(true);
	}


	public function deployProduction(){
		$this->stopOnFail(true);
		$user = 'root';
		$host = '195.201.38.163';
		$tmp = date('d-m-Y-h-i-s');
		$folder = 'api-borat.jmartz.de';
		$this->deploy($user,$host,$tmp,$folder);
	}

	public function deployDevelop(){
		$this->stopOnFail(true);
		$user = 'root';
		$host = '195.201.38.163';
		$tmp = date('d-m-Y-h-i-s');
		$folder = 'api-borat-dev.jmartz.de';
		$this->deploy($user,$host,$tmp,$folder);
	}

	public function deploy($user,$host,$tmp,$folder)
	{
		$this->taskSshExec($host, $user)
			 ->remoteDir('/var/www/' . $folder . '/releases')
			 ->exec('mkdir ' . $tmp)
			 ->run();
		$this->stopOnFail(false);

		$this->taskRsync()
			 ->fromPath('.')
			 ->toHost($host)
			 ->toUser($user)
			 ->verbose()
			 ->stats()
			 ->progress()
			 ->excludeVcs()
			 ->toPath('/var/www/' . $folder . '/releases/' . $tmp)
			 ->recursive()
			 ->run();

		$this->taskSshExec($host, $user)
			 ->remoteDir('/var/www/' . $folder)
			 ->exec('rm current')
			 ->exec('ln -sd /var/www/' . $folder . '/releases/' . $tmp . '/public current')
			 ->run();

		$this->taskSshExec($host, $user)
			 ->remoteDir('/var/www/' . $folder.'/releases')
			 ->exec('rm current')
			 ->exec('ln -sd /var/www/' . $folder . '/releases/' . $tmp . ' current')
			 ->run();

		$this->taskSshExec($host, $user)
			->remoteDir('/var/www/' . $folder . '/releases/current/src')
			 ->exec('ln -s /var/www/' . $folder . '/shared/.env')
			 ->run();

		$this->taskSshExec($host, $user)
			 ->remoteDir('/var/www/' . $folder.'/releases/current')
			 ->exec('ln -sd /var/www/' . $folder . '/shared/log')
			 ->run();

		$this->taskSshExec($host, $user)
			 ->remoteDir('/var/www/' . $folder)
			 ->exec('chown -R www-data:www-data /var/www/' . $folder)
			 ->run();

		$this->taskSshExec($host, $user)
			 ->remoteDir('/var/www/' . $folder)
			 ->exec('service php7.2-fpm restart')
			 ->run();
	}
}

?>
