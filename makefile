install:
	bin/composer install

start:
	php -S localhost:8080

test:
	# cd tst && ../vendor/bin/phpunit
	./vendor/bin/phpunit tst

lint:
	echo "=== PHP Lint ==="
	find . -type f -name "*.php" -not -path "./vendor/*" -exec php -l {} \;

	echo "=== PHP CodeSniffer ==="
	./vendor/bin/phpcs --extensions=php ./lib/

	echo "=== PHP Mess Detector ==="
	./vendor/bin/phpmd ./lib ansi codesize,unusedcode,naming
