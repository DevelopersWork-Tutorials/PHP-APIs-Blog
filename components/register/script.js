function register(){
  const form = document.forms["registerForm"]

  const data = {
    username : form["username"].value,
    password : form["password"].value,
    email : form["email"].value
  }

  $.ajax({
    url : "http://localhost/blog/api/v1/register",
    type : "POST",
    data : data,
    success : function(response){
      // console.log(response)
      const data = JSON.parse(response)
      // console.log(data)
      if(data.data.code){
        document.getElementById('response').innerHTML = data.data.message
      }else{
        document.getElementById('response').innerHTML = "Signup Successful... You'll be redirected in 3 Seconds"
        setTimeout(function(){
          window.top.location = '/blog/login'
        },3000);
      }

    },
    error : function(err){
      console.log(err)
    }
  })

}