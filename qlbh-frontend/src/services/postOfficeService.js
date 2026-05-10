import axios from "axios"

const API = "http://127.0.0.1:8000/api/postoffices"

export const getPostOffices = () => axios.get(API)
export const getPostOffice = (id) => axios.get(`${API}/${id}`)
export const createPostOffice = (data) => axios.post(API, data)
export const updatePostOffice = (id,data) => axios.put(`${API}/${id}`, data)
export const deletePostOffice = (id) => axios.delete(`${API}/${id}`)