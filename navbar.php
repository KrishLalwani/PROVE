<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <a href="home.php"><h3>PROVE</h3></a>
    </div>

    <ul class="list-unstyled components">
        <p>Menu</p>
        <li>
            <a href="searchpc.php">Search Computer</a>
        </li>
        <li class="active">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Member</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li><a href="addlab.php">Add Member</a></li>
                <li><a href="viewlab.php">View Members</a></li>
            </ul>
        </li>
        <li class="">
            <a href="#machinemenu" data-toggle="collapse" aria-expanded="false">Department</a>
            <ul class="collapse list-unstyled" id="machinemenu">
                <li><a href="addmc.php">Add Department</a></li>
                <li><a href="deletemc.php">View Departments</a></li>
            </ul>
        </li>

        <li class="">
            <a href="#devicemenu" data-toggle="collapse" aria-expanded="false">Role</a>
            <ul class="collapse list-unstyled" id="devicemenu">
                <li><a href="adddevice.php">Add Role</a></li>
                <li><a href="viewdev.php">View Roles</a></li>
            </ul>
        </li>

        <li class="">
            <a href="#specmenu" data-toggle="collapse" aria-expanded="false">Task</a>
            <ul class="collapse list-unstyled" id="specmenu">
                <li><a href="addspec.php">Create Task</a></li>
                <li><a href="deletespec.php">View Tasks</a></li>
            </ul>
        </li>

        <li class="">
            <a href="#contactmenu" data-toggle="collapse" aria-expanded="false">Contact</a>
            <ul class="collapse list-unstyled" id="contactmenu">
                <li><a href="#add_member.php">phadnis.anurag@gmail.com</a></li>
                <li><a href="#view_member.php">krishlalwani1@gmail.com</a></li>

            </ul>

        <hr>
        <li>
            <a href="logout.php">Logout</a>
        </li>
        <hr>
    <li class="">
            <a href="#developer">Developed By:</a>
            <ul class="list-unstyled" id="contactmenu">
                <li><a href="#view_member.php">Krish Lalwani</a></li>
                <li><a href="#add_member.php">Anurag Phadnis</a></li>
                <li><a href="#view_member.php">Husain Attari</a></li>
                <li><a href="#add_member.php">Aaditya Rathour</a></li>
            </ul>
    </li>
    <hr>
    </ul>
</nav>
<div class="container" id="content">
<div class="page-header">
<button type="button" id="sidebarCollapse" class="navbar-btn">
<span></span>
<span></span>
<span></span>
</button>
