<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<h1><?= $title ?></h1>
<p>Guess a number between 1 and 100, you have <?= $game->tries() ?> tries left.</p>

<form method="GET">
    <input type="hidden" name="number" value="<?= $game->number() ?>">
    <input type="hidden" name="tries" value="<?= $game->tries() ?>">
    <input type="text" name="guess" value="<?= $guess ?>" autofocus>
    <input type="submit" name="doGuess" value="Make a Guess" <?= $game->tries() < 1 ? "disabled" : "" ?>>
    <input type="submit" name="doCheat" value="Cheat">
</form>

<p>
    <a href="?reset">Reset game</a>
</p>

<?php if (isset($res)) : ?>
<p>Your guess <?= $guess ?> is <b><?= $res ?></b></p>
<?php endif; ?>

<?php if (isset($_GET["doCheat"])) : ?>
<p>Cheat: <?= $game->number() ?></p>
<?php endif; ?>
