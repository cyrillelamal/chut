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
