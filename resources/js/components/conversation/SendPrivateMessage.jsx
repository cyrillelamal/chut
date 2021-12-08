import React from "react";
import {Col, ListGroup, Row, Tab} from "react-bootstrap";
import FindUserForm from "./FindUserForm";
import UserPreview from "../user/UserPreview";
import UserMessageForm from "../message/UserMessageForm";
import {findUsers} from "../../services/users";

export default class SendPrivateMessage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            users: [],
            page: 1,
            last_page: null,
        };
    }

    setUsers = (users) => this.setState({users});

    action = (user) => `#user-${user.id}`;

    item = (user) => (
        <ListGroup.Item key={user.id} action href={this.action(user)}>
            <UserPreview {...user}/>
        </ListGroup.Item>
    );

    pane = (user) => (
        <Tab.Pane key={user.id} eventKey={this.action(user)}>
            <UserMessageForm {...user}/>
        </Tab.Pane>
    );

    handleQueryChange = (q = '') => {
        this.setState({page: 1, last_page: null, q});

        if ('' === q) {
            return this.setState({users: []});
        }

        findUsers(q)
            .then(
                ({data, meta}) => this.setState({last_page: meta.last_page, users: data})
            );
    }

    handleScroll = ({target}) => {
        const {scrollHeight, scrollTop, clientHeight} = target;
        if (clientHeight === scrollHeight - scrollTop) { // bottom
            this.setState((state) => {
                const {page, last_page, q} = state;

                if (last_page <= page) { // There are no more items.
                    return {page: last_page};
                }

                findUsers(q, page + 1)
                    .then(
                        ({data: users, meta}) => this.setState(
                            (state) => ({last_page: meta.last_page, users: [...state.users, ...users]})
                        )
                    );

                return {page: page + 1};
            });
        }
    }

    render() {
        return (
            <Tab.Container>
                <Row className="vh-100">
                    <Col sm="4" className="h-75 overflow-auto" onScroll={this.handleScroll}>
                        <ListGroup>
                            <ListGroup.Item action href="#search">
                                <FindUserForm setUsers={this.setUsers} handleChange={this.handleQueryChange}/>
                            </ListGroup.Item>
                            {this.state.users.map(this.item)}
                        </ListGroup>
                    </Col>
                    <Col sm="8">
                        <Tab.Content>
                            {this.state.users.map(this.pane)}
                        </Tab.Content>
                    </Col>
                </Row>
            </Tab.Container>
        );
    }
}
