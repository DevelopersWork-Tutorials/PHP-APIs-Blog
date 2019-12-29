function changePassword(){
  const form = document.forms["changePasswordForm"]

  const data = {
    password : form["password"].value,
    new_password : form["new_password"].value,
    username : form["username"].value
  }

  console.log(data)
  $.ajax({
    url : "http://localhost/blog/api/v1/changePassword",
    type : "POST",
    data : data,
    success : function(response){
      // console.log(response)
      const data = JSON.parse(response)
      // console.log(data)
      if(data.data.code){
        document.getElementById('response').innerHTML = data.data.message
      }else{
        document.getElementById('response').innerHTML = "PASSWORD UPDATED!!"
      }

    },
    error : function(err){
      console.log(err)
    }
  })

}