##
 # Development environment provided by external modules of Puppet Forge.
##
class external
{
	class {'env':
		utils        => ['git'],
		link_in_home => ['workspace=/vagrant'],
		aliases      => ['phpunit=clear ; phpunit'],
	}
	class {'vim':
		tabstop  => 4,
		opt_misc => ['number','nowrap'],
	}
	class {'php':
		modules => ['xdebug'],
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
