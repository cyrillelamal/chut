import axios from "axios";
import User from "../models/User";

/**
 * Get the current authenticated user.
 * @return {null|User}
 */
export const getUser = () => JSON.parse(localStorage.getItem('user'));

/**
 * Set CSRF token cookie.
 * Protect the user against CSRF.
 * @return {Promise<string>} CSRF token value.
 */
export const getCsrfToken = async () => {
    await axios.get('/sanctum/csrf-cookie');
    return document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        .split('=')[1];
}

/**
 * Sign up.
 * @param {{password: string, name: string, email: string}} data
 */
export const register = async (data) => {
    return axios.post('/api/register', data);
}

/**
 * Log in.
 * @param {{password: string, device_name: string, email: string}} data
 * @return {Promise<User>} Logged in user.
 */
export const login = async (data) => {
    const {email} = data;
    return axios.post('/api/login', Object.assign({'device_name': navigator.userAgent}, data))
        .then(() => {
            const user = new User(email);
            localStorage.setItem('user', JSON.stringify(user));
            return user;
        });
}

/**
 * Log out.
 * CSRF protection must be enabled.
 */
export const logout = async () => {
    return axios.post('/api/logout')
        .then(() => {
            localStorage.removeItem('user');
            return null;
        });
}
