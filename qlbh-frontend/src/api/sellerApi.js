// src/api/sellerApi.js
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/sellers";

export const getSellers = (search = "", page = 1) => {
  return axios.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getSeller = (id) => {
  return axios.get(`${API_URL}/${id}`);
};

export const createSeller = (data) => {
  return axios.post(API_URL, data);
};

export const updateSeller = (id, data) => {
  return axios.put(`${API_URL}/${id}`, data);
};

export const deleteSeller = (id) => {
  return axios.delete(`${API_URL}/${id}`);
};
