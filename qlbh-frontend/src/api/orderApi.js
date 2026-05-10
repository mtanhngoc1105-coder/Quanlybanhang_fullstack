// src/api/orderApi.js
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/orders";

export const getOrders = (search = "", page = 1) => {
  return axios.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getOrder = (id) => {
  return axios.get(`${API_URL}/${id}`);
};

export const createOrder = (data) => {
  return axios.post(API_URL, data);
};

export const updateOrder = (id, data) => {
  return axios.put(`${API_URL}/${id}`, data);
};

export const deleteOrder = (id) => {
  return axios.delete(`${API_URL}/${id}`);
};
