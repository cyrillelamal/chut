import axios from "axios";

/**
 * List conversation messages.
 * @param id Conversation id.
 * @param page Page number.
 */
export const getConversationMessages = (id, page = 1) => {
    const params = {page};

    return axios.get(`/api/conversations/${id}/messages`, {params})
        .then((response) => response.data);
}

/**
 * Create a new public conversation.
 * @param {Array<number>} users User identifiers.
 * @param {string|null} title Optional title.
 */
export const startConversation = (users = [], title = null) => {
    let data = {users};

    if (null !== title && undefined !== title) {
        data.title = title;
    }

    return axios.post('/api/conversations', data)
        .then((response) => response.data);
}
