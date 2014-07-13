##
 # Development environment provided by external modules of Puppet Forge.
##
class external
{
	class {'env':
		utils        => ['git'],
		link_in_home => ['workspace=/vagrant'],
		aliases      => ['phing=clear ; phing','phpunit=clear ; phpunit'],
	}
	class {'vim':
		tabstop  => 4,
		opt_misc => ['number','nowrap'],
	}
	class {'php':
		modules => ['xdebug'],
		extra   => [
			's3cmd','composer','phing','phpunit','phpdoc',
			'phpcs','phpdepend','phpmd','phpcpd','phpdcd',
		],
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
