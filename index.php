<!-- 22120123 - Long Nguyen - Practical 15:00 -> 17:00 -->

<?php
    require_once('session.php'); // start session
    $today = date('d/m/Y'); // date
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to TWACO</title>
    <link rel="stylesheet" href="css/project.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src=".\images\logo.png" alt="">
            <h1>Totally Wonderful Awnings</h1>
            <h2>Customer Orders</h2>

            <ul>
                <li><a href="login.php">Log In</a></li>
            </ul> 
        </div>

        <p class="appendix"><strong>Date: <?= $today ?></strong></p>

        <div class="columns">
            <div class="column-items">
                <h3>About</h3>
                <p>Fusce aliquam lorem id metus rhoncus venenatis. Nunc ac justo rhoncus, finibus augue non, pretium sem. Integer congue, sapien vitae tristique maximus, massa felis ullamcorper felis, vel vulputate metus augue sit amet arcu. Fusce luctus nisl nisi, ac facilisis justo efficitur quis. Maecenas lacinia auctor orci non laoreet. Quisque nibh leo, dictum vitae enim at, lobortis fermentum quam. Duis quis odio rutrum, lacinia erat vehicula, porttitor ipsum. Nulla aliquam, neque sit amet viverra auctor, lectus magna euismod tellus, ut molestie velit nunc sit amet turpis. Integer sit amet tempor lacus, eu fermentum magna. Integer ut commodo libero.</p>
            </div>
            <div class="column-items">
                <h3>Services</h3>
                <p>Vivamus semper, turpis vitae scelerisque ornare, purus ex euismod nisl, sit amet tincidunt lorem enim vitae ex. Vestibulum et maximus risus, non pulvinar lectus. Quisque non egestas felis. Nunc fermentum tortor quis fermentum condimentum. Curabitur consequat mollis ligula eu viverra. Proin id semper ante. Aenean convallis risus tellus, at auctor erat accumsan at. Proin rutrum tellus nec porttitor aliquet. Donec vulputate sem sit amet libero condimentum, rhoncus tincidunt orci volutpat.</p>
            </div>
            <div class="column-items">
                <h3>Products</h3>
                <p>Nunc nec neque nec metus dapibus porttitor. Sed id vehicula justo, eget pulvinar augue. Aenean ornare magna vitae purus dignissim feugiat. Nam interdum malesuada sollicitudin. Cras quis euismod mi, eget laoreet quam. Etiam vel tortor non nisi rutrum hendrerit. Proin dapibus id dolor at congue. Sed pretium massa risus, vel tincidunt lacus bibendum a. Suspendisse porta aliquet interdum.</p>
            </div>
            <div class="column-items">
                <h3>Privacy Policy</h3>
                <p>Donec sit amet euismod ligula, mollis elementum tellus. Nam cursus euismod nisl. Sed viverra mauris eros, at mattis augue vulputate sed. Aenean eget nisi facilisis, mollis libero vitae, dictum nibh. Fusce aliquet dui magna, in fermentum enim eleifend sit amet. Nullam at erat vitae sem placerat condimentum id quis risus. Mauris odio leo, placerat ut egestas nec, tristique sit amet mi. Donec ornare tortor at mauris blandit sollicitudin. Pellentesque gravida ultricies augue sit amet accumsan. Aliquam congue est eu viverra fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultrices ex ut libero euismod auctor. Ut ut dui non lorem eleifend rhoncus. Proin finibus odio nisi, vel dictum erat mollis ut. Aenean eros nunc, dignissim ut commodo id, vulputate et lectus.</p>
            </div>
            <div class="column-items">
                <h3>Contact Us</h3>
                <p>Maecenas ac consectetur est, at elementum erat. Fusce fringilla purus eu tempus ultricies. Duis nec arcu et purus vestibulum aliquam. Nullam leo felis, convallis eget ex et, eleifend rhoncus libero. Praesent eleifend, tellus congue euismod dictum, turpis libero consequat diam, in vestibulum sapien lectus et lectus. Maecenas elementum nec mi in cursus. Integer dolor velit, posuere eget luctus et, commodo sit amet sapien. Vestibulum vehicula est lacus, eu condimentum justo viverra sollicitudin. In lacinia magna eget congue iaculis. Ut eget bibendum felis. Nullam egestas velit ac ligula fringilla vestibulum. Vestibulum tempor libero risus, eget auctor mi suscipit eu. Integer ut felis ut nulla porta mollis. Praesent quis magna tincidunt, vulputate massa non, molestie diam. Donec in ante id massa posuere convallis. Nunc gravida at ipsum vitae sollicitudin.</p>
            </div>  
            <div class="column-items">
                <img src=".\images\service.jpg" alt="">
                <!-- Photo by Yan Krukau from Pexels -->
                <!-- Source: https://www.pexels.com/photo/happy-call-center-agents-looking-at-camera-8867482/-->
            </div>         
        </div>
        
        <p class="appendix"><strong><a href="login.php">Login</a></strong> to access all features</p>

    </div>
</body>
</html>