import React from "react";
import {useParams} from "react-router-dom";

import {getConversationMessages} from "../../services/conversations";
import Message from "./Message";
import MessageForm from "./MessageForm";
import {sendPublicMessage} from "../../services/messages";
import Navigation from "./Navigation";
import {bottom, demandNewPage} from "../../services/pagination";
import Notification from "../../models/Notification";
import LatestNotificationContext from "../notification/LatestNotificationContext";

class Conversation extends React.Component {
    constructor(props, context) {
        super(props, context);
        this.state = {
            messages: [],
            page: 1,
            last_page: null,
        };

        this.previousId = this.id;
        this.previousNotification = this.context;
    }

    componentDidMount() {
        getConversationMessages(this.id, 1)
            .then(({data, meta}) => ({messages: data, last_page: meta.last_page}))
            .then(this.setState.bind(this));
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (String(this.previousId) !== String(this.id)) {
            this.previousId = this.id;
            getConversationMessages(this.id, 1)
                .then(({data, meta}) => ({messages: data, last_page: meta.last_page}))
                .then(this.setState.bind(this));
        }

        if (this.previousNotification === this.context) {
            return;
        }

        if (Notification.TYPES.MESSAGE !== this.context.type) {
            return;
        }

        if (String(this.context.conversationId) !== String(this.id)) {
            return;
        }

        this.previousNotification = this.context;

        this.prependMessage(this.context.original);
    }

    handleScroll = ({target}) => {
        if (bottom(target)) {
            this.setState(
                (state) => {
                    const {page, last_page} = state;

                    const nextPage = demandNewPage(
                        page, last_page,
                        () => getConversationMessages(this.id, page + 1)
                            .then(({data: messages}) => this.appendMessages(messages))
                    );

                    return {page: nextPage};
                }
            );
        }
    }

    appendMessages = (messages = []) => {
        this.setState(state => ({messages: [...state.messages, ...messages]}));
    }

    prependMessage = (message) => {
        this.setState(state => ({messages: [message, ...state.messages]}));
    }

    send = (body) => {
        sendPublicMessage(this.id, body)
            .then(({data: message}) => this.prependMessage(message));
    }

    message = (m) => <Message key={m.id} {...m}/>

    render() {
        return (
            <div className="container p-3 py-4 vh-100">
                <div className="h-25">
                    <Navigation/>
                    <MessageForm conversationId={this.id} send={this.send}/>
                </div>
                <div className="h-75 overflow-auto p-4" onScroll={this.handleScroll}>
                    {this.messages.map(this.message)}
                </div>
            </div>
        );
    }

    get id() {
        return this.props.hasOwnProperty('params') ? this.props.params.id : null;
    }

    get messages() {
        return this.state.messages;
    }
}

Conversation.contextType = LatestNotificationContext;

const withRouter = (Component) => (props) => {
    const params = useParams();

    return <Component{...props} params={params}/>;
};

export default withRouter(Conversation);
