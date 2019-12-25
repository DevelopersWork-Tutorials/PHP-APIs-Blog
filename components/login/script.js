function login(){
  const form = document.forms["loginForm"]

  const data = {
    username : form["username"].value,
    password : form["password"].value
  }

  $.ajax({
    url : "http://localhost/blog/api/v1/login",
    type : "POST",
    data : data,
    success : function(response){
      const data = JSON.parse(response)

      if(data.data.code){
        document.getElementById('response').innerHTML = data.data.message
      }else{
        document.getElementById('response').innerHTML = "SUCCESS"
      }

    },
    error : function(err){
      console.log(err)
    }
  })

}