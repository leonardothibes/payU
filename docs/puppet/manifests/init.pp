##
 # Development environment provided by external modules of Puppet Forge.
##
class external
{
	class {'env':
		utils        => ['git','make','curl'],
		link_in_home => ['workspace=/vagrant'],
		aliases      => ['phpunit=clear ; phpunit'],
	}
	class {'vim':
		tabstop  => 4,
		opt_misc => ['number','nowrap'],
	}
	class {'php':
		modules => ['xdebug','curl'],
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
