package final_term_project;

import java.sql.*;

public class PO_DEPARTMENT_MST
{
 public static void main(String args[])
 {
   try{
     Class.forName("com.mysql.cj.jdbc.Driver");
     Connection con=DriverManager.getConnection(
     "jdbc:mysql://192.168.44.254:3308/MES",
     "mskang","1234");
     Statement stmt=con.createStatement();
     ResultSet rs=stmt.executeQuery("SELECT * FROM PO_DEPARTMENT_MST");
     while(rs.next())
     System.out.println(rs.getString(1)+" "+rs.getString(2)+
     " "+rs.getString(3));
     con.close();
   }catch(Exception e){ System.out.println(e);}
 }
}