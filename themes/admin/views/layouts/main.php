<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <title><?php echo $this->pageTitle; ?></title>
    </head>
    <body>
        <!-- HEADER -->
        <nav class="navbar navbar-inverse" role="navigation" style="border-radius:0px;">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand active" href="<?php $this->md("home", true) ?>"><?php echo $this->getBrandName() ?></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <?php if ($this->hasLoggedIn()): ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->getUsername() ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php $this->l($this->getLogoutUrl(), true); ?>">Log out <i class="icon-signout"></i></a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- /HEADER -->

        <div class="row">
            <div class="col-lg-3">
                <ul class="nav navbar-nav nav-stacked">
                    <?php foreach ($this->pages as $slug => $page): ?>
                        <?php if (isset($page["children"])): ?>
                            <li class="dropdown <?php if ($slug == $this->currentPage) echo 'active'; ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $page["title"] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php foreach ($page["children"] as $childSlug => $child): ?>
                                        <li>
                                            <a href="<?php $this->md("home/" . $childSlug, true) ?>">
                                                <?php if (isset($child["icon"])): ?><i class="<?php echo $child["icon"] ?>"></i><?php endif; ?>
                                                <?php echo $child["title"] ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="<?php if ($slug == $this->currentPage) echo 'active'; ?>"><a href="<?php $this->md("home/" . $slug, true) ?>"><?php echo $page["title"] ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <?php echo $content; ?>
            </div>
        </div>

        <!-- FOOTER -->
        <hr/>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <p><small><?php echo $this->getBrandName() ?> Copyright thanhtung9630@gmail.com - <?php echo date("Y") ?></small></p>
            </div>
        </div>
        <!-- /FOOTER -->
    </body>
</html>