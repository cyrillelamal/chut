import axios from "axios";

/**
 * Get the latest participations.
 * @param {number} page Page number.
 */
export const getLatestParticipations = (page = 1) => {
    const params = {page};

    return axios.get('/api/participations', {params})
        .then((response) => response.data);
}
