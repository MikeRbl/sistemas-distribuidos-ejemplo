import ServerConfig from "./config/server/ServerConfig";
import bodyParser from "body-parser";
import cors from "cors";

const server = ServerConfig.instance;

//bodyparser
server.app.use(bodyParser.urlencoded({ extended: true }));
server.app.use(bodyParser.json());

//cors
server.app.use(cors());

server.start(() => {
    console.log(`Server running on port ${server.port}`);
});

export default server;