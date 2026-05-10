// src/api/voucherApi.js
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/vouchers";

export const getVouchers = (search = "", page = 1) => {
  return axios.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getVoucher = (id) => {
  return axios.get(`${API_URL}/${id}`);
};

export const createVoucher = (data) => {
  return axios.post(API_URL, data);
};

export const updateVoucher = (id, data) => {
  return axios.put(`${API_URL}/${id}`, data);
};

export const deleteVoucher = (id) => {
  return axios.delete(`${API_URL}/${id}`);
};
