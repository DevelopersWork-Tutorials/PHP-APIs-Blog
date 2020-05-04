<?php
  // echo "works";
?>
<div class="container" id="content">

</div>
<script>
  const url = window.location.pathname
  const post_id = url.split("-").slice(-1)[0].split(".")[0]
  const formData = new FormData();
  formData.append("postid",post_id)
        fetch("http://localhost/blog/api/v1/readPost",{
          method : "POST",
          body : formData
        }).then(res => res.json())
        .then(res => {
          const content = res.data.content.join("")
          // console.log(res)
          document.getElementById('content').innerHTML = content
        }).catch(Err => console.log(Err))
</script>
