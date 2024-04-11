<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ask Codellama</title>
    <meta name="description" content="codellama-web-ui">
    <meta name="keywords" content="codellama-web-ui">
    <meta name="author" content="QuantumByteStudios">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">
    <!-- GoogleFonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Prism CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">
    <!-- Favicon -->
    <link rel="icon" href="https://ollama.com/public/icon-32x32.png">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <a class="navbar-brand" href=".">
                <h2><b>codellama-web-ui</b></h2>
            </a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a target="_blank" class="btn btn-dark m-1" data-bs-toggle="modal"
                        data-bs-target="#listModelsModal">
                        <i class="fa-regular fa-rectangle-list"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a target="_blank" class="btn btn-dark m-1"
                        href="https://github.com/QuantumByteStudios/codellama-web-ui">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Navbar -->

    <!-- list installed models -->
    <!-- Modal -->
    <div class="modal fade" id="listModelsModal" tabindex="-1" aria-labelledby="listModelsModalLabel" aria-hidden="true"
        style="--bs-modal-width: 700px !important;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="listModelsModalLabel">
                        List of Installed Models
                    </h1>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <?php
                        $listInstalledModels = 'ollama list';
                        $ResultListInstalledModels = shell_exec($listInstalledModels);
                        echo "<pre class='m-0'>{$ResultListInstalledModels}</pre><br>";
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
    <!-- list installed models -->

    <div class="container d-flex align-items-center justify-content-center">
        <!-- Content -->
        <div class="mt-5 p-5 animate__animated animate__fadeIn w-100">
            <!-- Input -->
            <div class="alert bg-dark fixed-bottom m-3">
                <form action="" method="POST">
                    <div class="btn-group w-100">
                        <input class="form-control fs-4 bg-transparent text-white rounded-0 rounded-start" type="text"
                            name="prompt" placeholder="Ask me something..." autocomplete="off">
                        <button class="btn btn-light rounded-end" type="submit">
                            <img width="30px" class="img-fluid" src="https://ollama.com/public/ollama.png" alt="">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notifications -->
            <div style="position: fixed; bottom: 15%; right: 1%; z-index: 1;" class="row">
                <div class="" id="alert"></div>
            </div>

            <!-- Output -->
            <div class="alert">
                <p>
                    <?php

                    $default = '
                    <div class="d-flex align-items-center">
                        <span><img width="30px" class="img-fluid" src="https://ollama.com/public/ollama.png" alt=""></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>Say something to the Codellama!</span>
                    </div>
                    ';

                    function printFormattedText($text)
                    {
                        preg_match('/```(.*?)```/s', $text, $matches);
                        $code = isset($matches[1]) ? $matches[1] : '';
                        $text = preg_replace('/```(.*?)```/s', '<div id="code"><pre><code class="language-javascript">' . $code . '</code></pre></div><button class="btn btn-outline-secondary mt-1 mb-3 btn-sm" onclick="copyToClipboard()"><i class="fa-solid fa-copy"></i> Code</button><br>', $text);
                        return $text;
                    }

                    function askCodeLlama($prompt)
                    {
                        if (empty($prompt)) {
                            global $default;
                            echo $default;
                            exit;
                        } else {

                            // GET THE OUTPUT FROM THE SHELL COMMAND
                            $command = 'ollama run codellama "' . $prompt . '"';
                            $output = shell_exec($command);

                            // DEBUGGING
                            //echo $output; // Output the raw output
                            //$output = 'To make a "Hello, World!" program in C, you can use the following code: ``` #include int main() { printf("Hello, World!\n"); return 0; } ``` This program will print the string "Hello, World!" to the screen when it is run. The `printf` function is used to print a string to the console. The `%s` format specifier is used to tell `printf` that the next argument is a string. In this case, the next argument is the string "Hello, World!". The `return 0;` statement at the end of the `main` function is optional and is included to ensure that the program exits cleanly. If you omit it, the program will continue to run until the user presses Ctrl+C or Ctrl+Z to stop it. To compile this program, you can use a C compiler such as GCC. On Linux or macOS, you can use the following command: ``` gcc hello-world.c -o hello-world ``` This will create an executable file called `hello-world` that can be run using `./hello-world`. On Windows, you can use a similar command but with a different extension: ``` gcc hello-world.c -o hello-world.exe ``` You can then run the program by typing `./hello-world` or `hello-world.exe` in the terminal.';
                    
                            // STAGE ONE FORMATTING - Replace new lines with <br> tags and remove backslashes
                            $new = nl2br($output);
                            $stage_one_formatting = str_replace('\n', '<br>', $new);
                            // echo $stage_one_formatting;
                    
                            // STAGE TWO FORMATTING - Highlight the code block
                            $stage_two_formatting = $stage_one_formatting;
                            echo printFormattedText($stage_two_formatting);
                        }
                    }

                    if (isset($_POST['prompt'])) {
                        $prompt = isset($_POST['prompt']) ? htmlspecialchars($_POST['prompt']) : '';
                        echo "<b>You</b> " . $prompt . "<br><br> <b>Codellama</b> ";
                        askCodeLlama($prompt);
                        echo "<br><br><br>";
                    } else {
                        echo $default;
                    }
                    ?>
                </p>
            </div>
        </div>
        <!-- Content -->
    </div>

</body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
<!-- Prism Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Prism.highlightAll();
    });

    //client-side validation
    document.querySelector('form').addEventListener('submit', function (event) {
        var promptInput = document.querySelector('input[name="prompt"]');
        if (!promptInput.value.trim()) {
            event.preventDefault();
            showAlert('Please enter a prompt.', 'danger');
        }
    });


    function showAlert(message, alertType) {
        var alert = document.getElementById('alert');
        alert.innerHTML = '<div style="border: 1px solid grey;" class="animate__animated animate__bounceInUp alert alert-' +
            alertType +
            ' alert-dismissible fade show" role="alert">' +
            message +
            '<button aria-label="Close" type="button" class="mx-2 btn btn-sm btn-dark" data-bs-dismiss="alert">Okay</button> </div> ';

        setTimeout(function () {
            alert.innerHTML = '';
        }, 4000);

        return;
    }

    function copyToClipboard() {
        var text = document.getElementById("code").innerText;

        var textArea = document.createElement("textarea");
        textArea.value = text;

        // Avoid scrolling to bottom
        textArea.style.top = "500";
        textArea.style.left = "500";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            showAlert("Code copied to clipboard", "light");
        } catch (err) {
            showAlert("Unable to copy code to clipboard. Please try again.", "danger");
        }

        document.body.removeChild(textArea);
    }
</script>

</html>