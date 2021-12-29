import axios from "axios";

const apiClient = axios.create({
    baseURL:'http://casteaching.test/api',
    withCredentials:false
    headers{
        Accept: 'application/json'
        'Content-type':'application/json'
    }
})

export default {
    videos: async function(){
       const response = await apiClient.get('/videos')
           console.log('RESPONSE:')
           console.log(response)
           return response.data
    }
}
