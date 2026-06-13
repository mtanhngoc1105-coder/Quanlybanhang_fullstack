// src/api/productApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/reviews";

export const getReviews = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getReview = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createReview = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updateReview = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deleteReview = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};
