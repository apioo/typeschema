<?php

chdir(__DIR__ . '/../www');
echo shell_exec('php vendor/bin/schema schema:parse -f html ../schema/schema.json ../schema/output');
