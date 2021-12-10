export default class Notification {
    static TYPES = {
        MESSAGE: 'message',
        CONVERSATION: 'conversation',
    };

    id = '';
    name = '';
    createdAt = '';
    body = '';
    conversationId = '';

    type = Notification.TYPES.MESSAGE;
    original = {};

    /**
     * Build a new notification from a message model.
     * @param {Object} message Message model.
     */
    static createFromMessage(message) {
        const {id, created_at: createdAt, body} = message;

        const {name} = message.author;
        const {conversation} = message;
        const {id: conversationId} = conversation;

        return Object.assign(
            new this(),
            {id, name, createdAt, body, conversationId, original: message}
        );
    }

    /**
     * Get unique react key.
     */
    get key() {
        return `message-${this.id}`;
    }
}
