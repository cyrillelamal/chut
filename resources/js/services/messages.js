import axios from "axios";

/**
 * Send a private message.
 * @param {number|string} userId User identifier.
 * @param {string} body Message body.
 */
export const sendPrivateMessage = (userId, body) => {
    const data = {body};

    return axios.post(`/api/users/${userId}/messages`, data)
        .then((response) => response.data);
}
