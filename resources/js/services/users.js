import axios from "axios";

/**
 * Find users by their email or name.
 * @param q Query string.
 * @param page Page number.
 */
export const findUsers = (q = '', page = 1) => {
    const params = {q, page};

    return axios.get('/api/users', {params})
        .then((response) => response.data);
}
