import Notification from "./Notification";

export default class Participation {
    title = '';
    body = '';
    updatedAt = '';
    conversationId = '';
    message = {};

    original = {};

    /**
     * @param {Notification} notification
     */
    static buildFromNotification(notification) {
        let visibleTitle = notification.name;
        let message = {};

        if (Notification.TYPES.MESSAGE === notification.type) {
            message = notification.original ?? {};
            const {conversation} = notification.original ?? {conversation: {}};
            if (undefined !== conversation.title && null !== conversation.title) {
                visibleTitle = conversation.title;
            }
        }


        const data = {
            conversation_id: notification.conversationId,
            visible_title: visibleTitle,
            last_available_message: Object.assign(message, {body: notification.body}),
            updated_at: notification.createdAt,
        };

        return Object.assign(new this(data), {original: notification});
    }

    constructor(data = {}) {
        const {conversation_id, visible_title, last_available_message, updated_at} = data;
        const {body} = last_available_message ?? {body: ''};

        Object.assign(this, {
            title: visible_title,
            body,
            updatedAt: updated_at,
            conversationId: conversation_id,
            message: last_available_message,
        });

        this.original = data;
    }

    /**
     * @param {Participation} other
     */
    isSame = (other) => {
        return String(other.href) === String(this.href);
    }

    get key() {
        return `${this.conversationId}-${this.messageId}`;
    }

    get href() {
        return `/conversations/${this.conversationId}`;
    }

    get messageId() {
        return this.message.id ?? '';
    }
}
