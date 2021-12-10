import React from "react";
import Authenticated from "../security/Authenticated";
import Navigation from "./Navigation";
import ParticipationList from "./ParticipationList";
import PrivateMessage from "./PrivateMessage";
import PublicConversation from "./PublicConversation";
import Navbar from "./Navbar";

export default class CommunicationCenter extends React.Component {
    static TABS = {
        PARTICIPATION_LIST: 'PARTICIPATION_LIST',
        PRIVATE_MESSAGE: 'PRIVATE_MESSAGE',
        PUBLIC_CONVERSATION: 'PUBLIC_CONVERSATION',
    }

    static _TABS = {
        PARTICIPATION_LIST: ParticipationList,
        PRIVATE_MESSAGE: PrivateMessage,
        PUBLIC_CONVERSATION: PublicConversation,
    }

    constructor(props) {
        super(props);
        this.state = {
            tab: CommunicationCenter.TABS.PARTICIPATION_LIST,
        };
    }

    render() {
        const Tab = CommunicationCenter._TABS[this.state.tab];

        return (
            <Authenticated>
                <div className="container p-3 py-4 vh-100">
                    <div className="h-25 d-flex flex-column justify-content-evenly">
                        <Navbar/>
                        <Navigation tab={this.state.tab} setTab={this.setTab}/>
                    </div>
                    <div className="h-75">
                        {<Tab/>}
                    </div>
                </div>
            </Authenticated>
        );
    }

    setTab = (tab) => {
        this.setState({tab});
    }
}
