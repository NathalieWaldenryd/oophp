<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

// $app->router->get("lek/hello-world-page", function () use ($app) {
//     $title = "Hello World as a page";
//     $data = [
//         "class" => "hello-world",
//         "content" => "Hello World in " . __FILE__,
//     ];

//     $app->page->add("anax/v2/article/default", $data);

//     return $app->page->render([
//         "title" => $title,
//     ]);
// });

/**
 * Showing message Hello World, not using the standard page layout.
 */
$app->router->get("gissa/get", function () use ($app) {

    $number = $_GET["number"] ?? -1;
    $tries = $_GET["tries"] ?? 6;
    $guess = $_GET["guess"] ?? null;
    
    $game = new \Naad17\Guess\Guess($number, $tries);
    
    if (isset($_GET["reset"])) {
        $game = new \Naad17\Guess\Guess($number, $tries);
    }
    
    $res = null;
    if (isset($_GET["doGuess"])) {
        $res = $game->makeGuess($guess);
    }

    $data = [
        "title" => "Gissa med GET",
        "game" => $game,
        "res" => $res,
        "guess" => $guess
    ];
    
    $app->page->add("guess/get", $data);
    return $app->page->render($data);
});



/**
 * Showing message Hello World, not using the standard page layout.
 */
$app->router->any(["GET", "POST"], "gissa/post", function () use ($app) {

    $number = $_POST["number"] ?? -1;
    $tries = $_POST["tries"] ?? 6;
    $guess = $_POST["guess"] ?? null;
    
    $game = new \Naad17\Guess\Guess($number, $tries);
    
    $res = null;
    if (isset($_POST["doGuess"])) {
        $res = $game->makeGuess($guess);
    }

    $data = [
        "title" => "Gissa med POST",
        "game" => $game,
        "res" => $res,
        "guess" => $guess
    ];
    
    $app->page->add("guess/post", $data);
    return $app->page->render($data);
});

$app->router->any(["GET", "POST"], "gissa/session", function () use ($app) {

    $title = "Guess my number (SESSION)";
    
    $number = $_SESSION["number"] ?? -1;
    $tries = $_SESSION["tries"] ?? 6;
    $guess = $_POST["guess"] ?? null;

    $game = new \Naad17\Guess\Guess($number, $tries);
    
    $_SESSION["number"] = $game->number();

    if (isset($_GET["reset"])) {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        header('Location: session');
        $app->page->add("guess/session", $data);
        return $app->page->render($data);
    }
    
    $res = null;
    if (isset($_POST["doGuess"])) {
        $res = $game->makeGuess($guess);
    }

    $_SESSION["tries"] = $game->tries();

    $data = [
        "title" => "Gissa med Session",
        "game" => $game,
        "res" => $res,
        "guess" => $guess
    ];
    
    $app->page->add("guess/session", $data);
    return $app->page->render($data);
});
