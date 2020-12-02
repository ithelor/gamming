<?php
require 'bootstrap.php';
?>

<html lang=en>
<link href=alt_styles.css rel=stylesheet />
<!--
<link rel="stylesheet" href="dark.scss">
<script src="sweetalert2.js"></script>
-->

    <head>
        <title>Registration</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-4">
                    <form id="registration">
                        <div class="form-group" style="margin-top: 2em">
                            <label>E-Mail</label>
                            <label for="email"></label><input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter E-Mail">
                            <div class="form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="name">Nickname</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter nickname">
                            <div class="form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            <div class="form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="repeat-password">Repeat password</label>
                            <input type="password" class="form-control" id="repeat-password" name="repeat-password" placeholder="Confirm password">
                            <div class="form-control-feedback"></div>
                        </div>
                        <!--<button type="submit" class="btn btn-primary">Зарегистрироваться</button>-->
                        <div class="wrapper" style="font-size:1.5em; margin-top: 2em; margin-bottom: 2em">
                            <button type="submit" class="bouncy">Register</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-10">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nickname</th>
                                <th>Email</th>
                                <th>Registered at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $users = getUsersList();
                            ?>

                            <?php if(!empty($users)): ?>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <th scope="row"><?= $user['id'] ?></th>
                                        <th><?= $user['name'] ?></th>
                                        <th><?= $user['email'] ?></th>
                                        <th><?= $user['created_at'] ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="form.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>-->
    </body>
</html>