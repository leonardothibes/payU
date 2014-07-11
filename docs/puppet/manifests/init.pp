##
 # Development environment provided by external modules of Puppet Forge.
##
class external
{
	class {'env':
		utils        => ['git','curl','wget'],
		link_in_home => ['workspace=/vagrant'],
		aliases      => ['phing=clear ; phing','phpunit=clear ; phpunit'],
	}
	class {'vim':
		tabstop  => 4,
		plugins  => ['puppet'],
		opt_misc => ['number','nowrap'],
	}
	class {'php':
		modules => ['apc'],
		extra   => [
			's3cmd','composer','phing','phpunit','phpdoc',
			'phpcs','phpdepend','phpmd','phpcpd','phpdcd',
		],
	}
	class {'zf':
		version => 1,
		zftool  => true,
	}
	class {'apache':
		default_mods  => true,
		default_vhost => false,
		mpm_module    => 'prefork',
	}
	apache::mod {'php5':}
	apache::mod {'rewrite':}
	apache::vhost {'app':
		priority => '00',
		port     => '80',
		override => 'FileInfo',
		docroot  => '/vagrant/src/payU/public',
		setenv   => ['APPLICATION_ENV development'],
	}
}

##
 # Development environment provided by local modules.
##
class local
{
	include ssh
}

class {'external':}
class {'local':}
