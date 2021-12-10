/**
 * Finds whether the bottom of an overflown element has been reached.
 * Normally, you would pass to this function the event target.
 * @param {number} scrollHeight
 * @param {number} scrollTop
 * @param {number} clientHeight
 * @return {boolean}
 */
export const bottom = ({scrollHeight, scrollTop, clientHeight}) => clientHeight === scrollHeight - scrollTop;


/**
 * Call the provided function only if there are more pages.
 * @param page Current page number.
 * @param lastPage Next page number.
 * @param {Function} f Function called only if there are more pages.
 * @return {number} Next available page number.
 */
export const demandNewPage = (page = 1, lastPage = 1, f = () => null) => {
    if (lastPage <= page) {
        return lastPage;
    }

    f();

    return page + 1;
}
