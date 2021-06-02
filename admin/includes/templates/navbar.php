<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="home.php"><?php echo lang('HOME'); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="member.php?do=manage&page=all"><?php echo lang('STUDENTS'); ?></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user-circle"></i ><?php echo $_SESSION['username']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="member.php?do=edit&userid=<?php echo $_SESSION['ID']; ?>"><?php echo lang('EDIT_PROFILE'); ?></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"><?php echo lang('LOG_OUT'); ?></a>
        </div>
      </li>
    </ul>
  </div>
</nav>