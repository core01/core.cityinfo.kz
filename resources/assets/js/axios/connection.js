import axios from 'axios'

const LOGIN_URL = '/login'

export const connection = (options = {}) => {
  const instance = axios.create(options)

  instance.interceptors.response.use(
    function(response) {
      return response
    },
    function(error) {
      switch (error.response.status) {
        case 401:
          location.href = LOGIN_URL
          break
        default:
          console.log(error.response)
      }
      return Promise.reject(error)
    }
  )

  return instance
}
export default connection
