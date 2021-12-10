import axios from "axios";

/**
 * Get subscription channels available for the current user.
 */
export const discoverChannels = async () => {
    return axios.get('/api/discovery')
        .then((response) => response.data);
}
