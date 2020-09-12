#!/bin/bash

\pushd . > /dev/null
	INIT_SOURCE=${BASH_SOURCE[0]}
	if [ -z $INIT_SOURCE ];then
		INIT_SOURCE=$(echo .)
	fi

	BASEDIR="${INIT_SOURCE}"
	if ([ -h "${BASEDIR}" ]); then
  		while ([ -h "${BASEDIR}" ]);do
  			cd $(dirname "$BASEDIR");
  			BASEDIR=$(readlink "${BASEDIR}");
		done
	fi
	cd $(dirname ${BASEDIR}) > /dev/null
	BASEDIR=$(pwd)
\popd  > /dev/null


##Aliases definition
alias phpunit='${BASEDIR}/vendor/bin/phpunit'
alias punit='phpunit --testdox'
alias dumpRouteLoader='\pushd ${BASEDIR}/dev > /dev/null && ./dumpRouteLoader.sh && \popd > /dev/null'
alias npmr='npm run'

