import axios from "axios"
const API = axios.create({
  baseURL: "https://api-nienluan.sharenows.com/api/v1/"
})

API.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token")
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

export default API
