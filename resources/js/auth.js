export default function (Vue) { 
    Vue.auth = {
        setToken(token, usertype, user, setting) { 
            localStorage.setItem('token', token)
            localStorage.setItem('usertype', usertype)
            localStorage.setItem('user', user)
            localStorage.setItem('setting', setting)
        },
        getToken() { 
            var token = localStorage.getItem('token')
            // var usertype = localStorage.getItem('usertype')
            // var user = localStorage.getItem('user')
            if (!token) {
                this.destroyToken()
                return null
            }
            else { 
                return token
            }
        },
        destroyToken() { 
            localStorage.removeItem('token')
            localStorage.removeItem('usertype')
            localStorage.removeItem('user')
            localStorage.removeItem('setting')
        }
    }

    Object.defineProperties(Vue.prototype, {
        $auth: {
            get: () => {
                return Vue.auth
            }
        }
    })
}