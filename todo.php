<?php
include 'menu.php';
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - <?= $siteTitle ?></title>

    <?php include 'view/css.txt' ?>

    <!-- Custom CSS -->
    <style>
        .completed .widget-todo-title {
            text-decoration: line-through;
            color: gray;
        }
    </style>
    <link rel="stylesheet" href="./assets/compiled/css/ui-widgets-todolist.css">

    <!-- Meta Tag -->
    <?php include 'view/meta.txt' ?>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include 'view/sidebar.txt' ?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <?php include 'view/navbar.txt' ?>
            
            <div id="main-content">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Lorem, ipsum.</h3>
                        <p class="text-subtitle text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, cumque!</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <?php foreach ($dataMenu as $menuItem): ?>
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $menuId; ?></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $menuItem['title']; ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Your content -->
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card widget-todo">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h4 class="card-title d-flex">
                                    <i class="bx bx-check font-medium-5 pl-25 pr-75"></i>Tasks
                                </h4>
                                <ul class="list-inline d-flex mb-0">
                                    <li class="d-flex align-items-center">
                                        <i class="bx bx-check-circle font-medium-3 me-50"></i>
                                        <div class="dropdown">
                                            <div class="dropdown-toggle me-1" role="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Task
                                            </div>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Option 1</a>
                                                <a class="dropdown-item" href="#">Option 2</a>
                                                <a class="dropdown-item" href="#">Option 3</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="bx bx-sort me-50 font-medium-3"></i>
                                        <div class="dropdown">
                                            <div class="dropdown-toggle" role="button" id="dropdownMenuButton2"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Task
                                            </div>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <a class="dropdown-item" href="#">Option 1</a>
                                                <a class="dropdown-item" href="#">Option 2</a>
                                                <a class="dropdown-item" href="#">Option 3</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body px-0 py-1 overflow-auto">
                                <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                                    <li class="widget-todo-item">
                                        <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                            <div class="widget-todo-title-area d-flex align-items-center gap-2">
                                                <div class="checkbox checkbox-shadow">
                                                    <input type="checkbox" class="form-check-input" id="checkbox-1">
                                                </div>
                                                <label for="checkbox-1" class="widget-todo-title ms-2">Add SCSS and JS files if required</label>
                                            </div>
                                            <div class="widget-todo-item-action d-flex align-items-center">
                                                <div class="badge badge-pill bg-light-success me-1">frontend</div>
                                            </div>
                                            <div class="widget-todo-item-action d-flex align-items-center">
                                                <i data-feather="list" class="cursor-move"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="widget-todo-item">
                                        <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                            <div class="widget-todo-title-area d-flex align-items-center gap-2">
                                                <div class="checkbox checkbox-shadow">
                                                    <input type="checkbox" class="form-check-input" id="checkbox-2">
                                                </div>
                                                <label for="checkbox-2" class="widget-todo-title ms-2">Add SCSS and JS files if required</label>
                                            </div>
                                            <div class="widget-todo-item-action d-flex align-items-center">
                                                <div class="badge badge-pill bg-light-success me-1">frontend</div>
                                            </div>
                                            <div class="widget-todo-item-action d-flex align-items-center">
                                                <i data-feather="list" class="cursor-move"></i>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'view/footer.txt' ?>
        </div>
    </div>

    <?php include 'view/js.txt' ?>

    <!-- Custom JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('widget-todo-list');
            Sortable.create(el, {
                animation: 150,
                handle: '.cursor-move', // Class of the handle for drag action
                ghostClass: 'sortable-ghost', // Class name for the drop placeholder
                onStart: function (/**Event*/evt) {
                    evt.item.classList.add('dragging');
                },
                onEnd: function (/**Event*/evt) {
                    evt.item.classList.remove('dragging');
                }
            });

            document.querySelectorAll('.widget-todo-item').forEach(function(item) {
                var checkbox = item.querySelector('input[type="checkbox"]');
                var label = item.querySelector('.widget-todo-title');
                
                function toggleCompleted() {
                    if (checkbox.checked) {
                        item.classList.add('completed');
                    } else {
                        item.classList.remove('completed');
                    }
                }

                checkbox.addEventListener('change', toggleCompleted);

                label.addEventListener('click', function() {
                    checkbox.checked = !checkbox.checked;
                    toggleCompleted();
                });
            });
        });
    </script>
</body>

</html>
