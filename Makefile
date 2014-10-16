# Makefile - A courtesy of leonardothibes\PayU.
#
# A collection of reusable tasks for automating some process.
#
# Make sure you have GNU Make and GNU curl, and then type "make" in this Makefile folder.
#

# General Configuration
NAME       = "leonardothibes/PayU"
VERSION    = "0.5-beta3"
AUTHOR     = "Leonardo Thibes"
STANDARD   = "PSR2"
BASEDIR    = `pwd`
BIN        = "${BASEDIR}/bin"
SRC        = "${BASEDIR}/src"
DOCS       = "${BASEDIR}/docs"
BUILD      = "${BASEDIR}/build"
TESTS      = "${BASEDIR}/tests"
VENDOR     = "${BASEDIR}/vendor"
LOGS       = "${BASEDIR}/logs"
TMP        = "/tmp"
DATE       = `date "+%Y-%m-%d"`
LOGFILE    = "${LOGS}/debug_${DATE}.log"
URI        = "leonardothibes/payU"
DOCUMENTUP = "http://documentup.com/${URI}"
GITHUB     = "http://github.com/${URI}"

build: .clear .title .init lint code-sniffer test-analyze phpmd phpcpd phpdcd phploc phpdoc documentup
	@echo ""
	@echo " - BUILD SUCCESS!"
	@echo ""

.init:
	@if [ ! -d ${VENDOR} ]; then \
		echo 'Environment not initialized!'; \
		echo 'Try "make install-dev" first!'; \
		echo ''; \
		exit 1; \
	fi; \

rw:
	@[ -d ${BIN}     ] || mkdir ${BIN}
	@[ -d ${BUILD}   ] || mkdir ${BUILD}
	@[ -d ${LOGS}    ] || mkdir ${LOGS}
	@[ -f ${LOGFILE} ] || > ${LOGFILE}
	@chmod -R 777 ${LOGS}

clean:
	@rm -Rf ${LOGS}/*
	@rm -Rf ${BUILD}/*
	@find ${BASEDIR} | grep .DS_Store | xargs rm -f
	@find ${BASEDIR} | grep Thumbs.db | xargs rm -f

clean-all:
	@rm -Rf ${VENDOR}
	@rm -Rf ${BUILD}
	@rm -Rf ${LOGS}
	@rm -Rf ${BIN}
	@rm -f composer.lock

.composer: rw
	@if [ ! -f ${BIN}/composer.phar ]; then \
		curl -sS https://getcomposer.org/installer | php -- --install-dir=${BIN}; \
	fi; \

install: rw .clear .composer
	@php ${BIN}/composer.phar install --no-dev

install-dev: rw .clear .phpDocumentor .composer
	@php ${BIN}/composer.phar install --dev

classmap:
	@php ${BIN}/composer.phar dump-autoload

lint: .clear
	@for file in `find ./src` ; do \
		results=`php -l $$file`; \
		if [ "$$results" != "No syntax errors detected in $$file" ]; then \
			echo $$results; \
			echo ""; \
			exit 1; \
		fi; \
	done;
	@echo " - No syntax errors detected"
	
test: rw .clear
	@${BIN}/phpunit -c ${TESTS}/phpunit.xml ${TESTS}

testdox: rw .clear
	@${BIN}/phpunit -c ${TESTS}/phpunit.xml --testdox ${TESTS}

test-analyze: rw .clear
	@${BIN}/phpunit -c ${TESTS}/phpunit.xml  \
		--testdox-html=${BUILD}/testdox.html \
		--coverage-html=${BUILD}/coverage    \
		${TESTS} 1> /dev/null 2> /dev/null
	@echo " - Test reports generated!"

code-sniffer: .clear
	@${BIN}/phpcs --standard=${STANDARD} ${SRC}
	@echo " - No code standards violation detected"

phpmd: rw .clear
	@trap "${BIN}/phpmd --suffixes php ${SRC} html cleancode,codesize,controversial,design,naming,unusedcode --reportfile ${BUILD}/pmd.html" EXIT
	@echo " - Mess detector report generated"

phpcpd: rw .clear
	@trap "${BIN}/phpcpd --log-pmd=${BUILD}/phpcpd.xml ${SRC} > /dev/null" EXIT
	@echo " - Duplicated lines report generated"

phpdcd: rw .clear
	@${BIN}/phpdcd ${SRC} > ${BUILD}/phpdcd.txt
	@echo " - Dead code report generated"

phploc:
	@${BIN}/phploc ${SRC} > ${BUILD}/phploc.txt
	@echo " - Measure project report generated"

.phpDocumentor:
	@[ -f ${TMP}/phpDocumentor.phar ] || curl http://phpdoc.org/phpDocumentor.phar -o ${TMP}/phpDocumentor.phar
	@[ -f ${BIN}/phpDocumentor.phar ] || cp -f ${TMP}/phpDocumentor.phar ${BIN}/phpDocumentor.phar	
	@[ -f ${BIN}/phpDocumentor.phar ] && chmod 755 ${BIN}/phpDocumentor.phar

phpdoc: rw .clear .phpDocumentor
	@php ${BIN}/phpDocumentor.phar -d ${SRC} -t ${BUILD}/apidoc 1> /dev/null 2> /dev/null
	@echo " - Code documentation generated"

documentup:
	@echo " - Recompiling online documentation on ${DOCUMENTUP}"
	@curl -X GET ${DOCUMENTUP}/recompile 1> /dev/null 2> /dev/null

version: .title

.clear:
	@clear

.title:
	@echo "# ${NAME} ${VERSION} by ${AUTHOR}."
	@echo ""

help: .clear .title
	@echo "Usage: make [options]"
	@echo ""
	@echo "  build[default]     General project build"
	@echo "  rw                 Create dirs: bin, build, logs"
	@echo "  clean              Clean build and log files"
	@echo "  clean-all          Clean all development stuff(build, logs, vendors...)"
	@echo "  install            Install project dependencies for production"
	@echo "  install-dev        Install project development dependencies for developers"
	@echo "  classmap           Generate a composer autoloader classmap"
	@echo "  lint               Search syntax errors in project"
	@echo "  test               Execute all unit tests"
	@echo "  testdox            Execute all unit tests and show in list"
	@echo "  test-analyze       Execute all unit tests and generate a code coverage reports"
	@echo "  code-sniffer       Search for code standard(${STANDARD}) violations in project"
	@echo "  phpmd              Generate a mess detector report"
	@echo "  phpcpd             Generate a copy-paste report"
	@echo "  phpdcd             Generate a dead code report"
	@echo "  phploc             Generate a measure project report"
	@echo "  phpdoc             Generate API documentation"
	@echo "  documentup         Update a project's website -> ${DOCUMENTUP}"
	@echo "  version            Show the ${NAME} version number"
	@echo "  help               Show this HELP message"
	@echo ""