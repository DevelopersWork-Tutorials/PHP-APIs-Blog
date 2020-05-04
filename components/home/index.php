<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home - Developers@Work</title>
  
  <script src="/blog/components/home/script.js"></script>
  <link rel="stylesheet" href="/blog/components/home/style.css">

</head>
<body>
  <h1>

    Welcome to the World of Developers@Work

  </h1>
  <?php if(!isset($_SESSION["uid"])){ ?>

    <a href="/blog/login">
      <button class="btn btn-outline-primary">LOGIN</button>
    </a>
    <a href="/blog/register">
      <button class="btn btn-outline-primary">REGISTER</button>
    </a>
  <?php }else{?>
    <a href="/blog/dashboard">
      <button class="btn btn-outline-primary">DASHBOARD</button>
    </a>
  <?php }?>
  <div class="container">
    <div class="row" id="posts_container">

      <script>
        fetch("http://localhost/blog/api/v1/getPosts",{
          method : "POST",
          headers  : {
            'Accept-Type' : 'application/json',
            'Content-Type' : 'application/json'
          },
          body : JSON.stringify({
            offset  : 0,
            limit : 6
          })
        }).then(res => res.json())
        .then(res => {
          const posts = res.data.posts
          posts.map(post => {
            const card = document.createElement('div')
            card.setAttribute("class","card col-4")

            card.innerHTML = '<div class="card-body">\
                <h5 class="card-title">'+post.title+'</h5>\
                <h6 class="card-subtitle mb-2 text-muted">'+post.publishedOn+'</h6>\
                <p class="card-text"></p>\
                <a href="#" class="card-link">'+post.author+'</a>\
                <a href="#" class="btn btn-outline-secondary card-link">VIEW POST</a>\
              </div>'

            document.getElementById('posts_container').appendChild(card)
          })
        }).catch(Err => console.log(Err))

      </script>

    </div>
  </div>
</body>
</html>