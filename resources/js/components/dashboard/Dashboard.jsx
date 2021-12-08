import React from "react";
import ParticipationList from "../conversation/ParticipationList";
import {Tab, Tabs} from "react-bootstrap";
import SendPrivateMessage from "../conversation/SendPrivateMessage";
import StartConversation from "../conversation/StartConversation";

export default class Dashboard extends React.Component {
    render() {
        return (
            <div className="container py-5">
                <Tabs defaultActiveKey="start-conversation" id="dashboard-tabs" className="mb-3">
                    <Tab eventKey="participation-list" title={'Recent dialogues'}>{/* TODO: i18n */}
                        <ParticipationList/>{/* TODO: impl */}
                    </Tab>
                    <Tab eventKey="user-message" title={'Send private message'}>{/* TODO: i18n */}
                        <SendPrivateMessage/>
                    </Tab>
                    <Tab eventKey="start-conversation" title={'Start public conversation'}>{/* TODO: i18n */}
                        <StartConversation/>{/* TODO: impl */}
                    </Tab>
                </Tabs>
            </div>
        );
    }
}
