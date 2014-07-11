class ssh
{
	file {'/home/vagrant/.ssh/id_rsa':
		ensure => link,
		target => '/home/.ssh/id_rsa',
	}
	file {'/home/vagrant/.ssh/id_rsa.pub':
		ensure => link,
		target => '/home/.ssh/id_rsa.pub',
	}
}
