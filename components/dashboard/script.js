function logout() {

    $.ajax({
        url: "http://localhost/blog/api/v1/logout",
        type: "POST",
        success: function(response) {
            // console.log(response)
            const data = JSON.parse(response)
                // console.log(data)
            if (data.data.code) {
                document.getElementById('response').innerHTML = data.data.message
            } else {
                document.getElementById('response').innerHTML = "Logout Successful... You'll be redirected in 3 Seconds"
                setTimeout(function() {
                    window.top.location = '/blog/login'
                }, 3000);
            }

        },
        error: function(err) {
            console.log(err)
        }
    })

}

function getServices() {
    fetch("http://localhost/blog/api/v1/getClaims", {})
        .then(res => res.json())
        .then(res => {
            // console.log(res)
            const data = res.data
            const root = data.filter(service => service.service_parent == null).map(service => {
                const a = document.createElement("a")
                const button = document.createElement("button")

                button.innerText = service.service_name
                button.setAttribute("class", "btn btn-outline-primary")
                a.append(button)
                a.href = "/blog/" + service.service_name.toLowerCase()

                document.getElementById("dashboard").appendChild(a)
                return a
            })

        })
        .catch(err => {
            console.log(err)
        })
}