// src/api/voucherApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/api/vouchers";

export const getVouchers = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getVoucher = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createVoucher = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updateVoucher = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deleteVoucher = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};
