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

/**
 * Send a public message.
 * @param {number|string} conversationId Conversation identifier.
 * @param {string} body Message body.
 */
export const sendPublicMessage = (conversationId, body) => {
    const data = {body};

    return axios.post(`/api/conversations/${conversationId}/messages`, data)
        .then((response) => response.data);
}
