import {connect} from './DatabaseConnection';
import { RowDataPacket } from 'mysql2/promise';

class DatabaseMethods {
    static async save(sql: {query : string; params: any[]}) {
       let connection;
       try{
            connection =  await connect();
            await connection.execute(sql.query, sql.params);
            return {error: false, msg: "Query executed"};
       } catch (error) {
            return {error: true, msg: "error save"};
       } finally {
            if (connection) connection.end();
       }
    }
}

export {DatabaseMethods};