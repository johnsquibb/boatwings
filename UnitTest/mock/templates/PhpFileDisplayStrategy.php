<?php
// Example of \BoatWings\Template\DisplayStrategy\PhpFileDisplayStrategy usage.
// @see UnitTest/TemplateTest::testPhpFileDisplayStrategy() for more details.
?>
<html>
	<head></head>
	<body>
		<h1>Some Values interpolated from data array</h1>
		<ul>
			<li>A: <?= $a ?></li>
			<li>B: <?= $b ?></li>
			<li>C: <?= $c ?></li>
		</ul>
	</body>
</html>