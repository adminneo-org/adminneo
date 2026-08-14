ROOT_DIRECTORY = $(shell dirname "$(realpath $(lastword $(MAKEFILE_LIST)))")
PHP := $(shell which php)
PORT := 8000


.DEFAULT_GOAL := default


.PHONY: default
default: compile

.PHONY: compile
compile:
	$(PHP) $(ROOT_DIRECTORY)/bin/compile.php

.PHONY: server
server:
	php \
	  --server 127.0.0.1:$(PORT) \
	  --docroot $(ROOT_DIRECTORY)

.PHONY: clean
clean:
	rm -rf $(ROOT_DIRECTORY)/compiled/admin*.php $(ROOT_DIRECTORY)/compiled/editor*.php $(ROOT_DIRECTORY)/adminneo-plugins

.PHONY: clean.all
clean.all: clean
