import React from "react";
import {useParams} from "react-router-dom";
import {getConversationMessages} from "../../services/conversations";
import Message from "./Message";
import MessageForm from "./MessageForm";
import {sendPublicMessage} from "../../services/messages";
import Navigation from "./Navigation";

class Conversation extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            messages: [],
            page: 1,
            last_page: null,
        };
    }

    componentDidMount() {
        getConversationMessages(this.id, 1)
            .then(
                ({data, meta}) => this.setState({messages: data, last_page: meta.last_page})
            );
    }

    handleScroll = (e) => {
        const {scrollHeight, scrollTop, clientHeight} = e.target;

        if (clientHeight === scrollHeight - scrollTop) { // bottom
            this.setState(
                (state) => {
                    const {page, last_page} = state;

                    if (last_page <= page) {
                        return {page: last_page};
                    }

                    getConversationMessages(this.id, page + 1)
                        .then(
                            ({data}) => this.setState(
                                (state) => ({messages: [...state.messages, ...data]})
                            )
                        );

                    return {page: page + 1};
                }
            );
        }
    }

    send = (body) => {
        sendPublicMessage(this.id, body)
            .then(({data}) => data)
            .then(
                (message) => this.setState(
                    (state) => ({messages: [message, ...state.messages]})
                )
            );
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

const withRouter = (Component) => (props) => {
    const params = useParams();

    return <Component{...props} params={params}/>;
};

export default withRouter(Conversation);
