<section class="content-header">
    <span class="content-title"><i class="fa fa-user"></i> <?= $profile->login ?></span>
</section>
<section class="content">
   <div class="col-sm-9">
       <div class="panel panel-primary">
           <div class="panel-heading">
               <h3><i class="fa fa-user"></i>User info</h3>
           </div>
           <div class="panel-body">
               <div class="form-group">
                   <label>User name</label> :
                   <span><?= $profile->login ?></span>
               </div>
               <div class="form-group">
                   <label>Email</label> :
                   <span><?= $profile->email ?></span>
               </div>
               <div class="form-group">
                   <label>First name</label> :
                   <span><?= $profile->fname ?></span>
               </div>
               <div class="form-group">
                   <label>Last name</label> :
                   <span><?= $profile->lname ?></span>
               </div>
               <div class="form-group">
                   <label>Job title</label> :
                   <span><?= $profile->function ?></span>
               </div>
               <div class="form-group">
                   <label>Telephone</label> :
                   <span><?= $profile->phone ?></span>
               </div>
               <div class="form-group">
                   <label>Role</label> :
                   <span><?= $profile->role_name ?></span>
               </div>
           </div>
       </div>
   </div>
   <div class="col-sm-3">
       <div class="panel panel-primary profile-side">
           <div class="panel-heading text-center">
               <img class="avatar avatar-lg border-lg" src="img/avatar/<?= $profile->avatar ?>">
               <h4><?= $profile->fname.' '.$profile->lname ?></h4>
               <small><?= $profile->function ?></small>
           </div>
           <?php if(isset($_SESSION['user']) && ($_SESSION['user']->id == $_GET['id'])): ?>
           <div class="panel-body">
               <ul class="nav nav-pills">
                   <li><a href="<?= App::$path ?>user/profileedit/<?= $profile->id ?>"><i class="fa fa-edit"></i>Edit profile</a></li>
               </ul>
           </div>
           <?php endif; ?>
       </div>
   </div>
</section>
