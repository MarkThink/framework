<?php

//$input = $request->get('name', 'World');
//$response->setContent(sprintf('Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8')));

$name = $request->get('name','World'); ?>

Hello <?php echo htmlspecialchars($name,ENT_QUOTES,'utf-8');?>
