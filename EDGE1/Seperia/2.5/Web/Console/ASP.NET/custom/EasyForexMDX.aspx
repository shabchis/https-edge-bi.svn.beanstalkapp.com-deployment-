<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="EasyForexMDX.aspx.cs" Inherits="EdgeWebTools.EasyForexMDX" %>
<%@ Import Namespace="System.Data.SqlClient" %>
<%@ Import Namespace="Easynet.Edge.Core.Configuration" %>
<%@ Import Namespace="Easynet.Edge.Core.Data" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <title>Easy Forex Weekly Report</title>
    <link href="<%= ResolveUrl("~/style.css") %>" rel="stylesheet" type="text/css" />
</head>
<body>
    <form id="form1" runat="server">
    <div>
    <asp:ScriptManager ID="ScriptManager1" runat="server" EnablePartialRendering="true" />
    
    <script type="text/javascript">
        function editQuery() {
            var query = document.getElementById('_query');
            if (query.style.display == 'none') {
                query.style.display = '';
            }
            else {
                query.style.display = 'none';
            }
        }
    </script>
    <img alt="edge2" src="<%= ResolveUrl("~/easynet_edge_logo.png") %>"  />
    <br />
    &nbsp;<br />
                         <br />
                         <br />
                         <asp:UpdatePanel ID="UpdatePanel1" ChildrenAsTriggers="true" runat="server">
							<ContentTemplate>
								<asp:Calendar runat="server" id="_fromDate">
									<SelectedDayStyle BackColor="#666666" Font-Bold="True" ForeColor="White" />
									<SelectorStyle BackColor="#CCCCCC" />
									<WeekendDayStyle BackColor="#FFFFCC" />
									<TodayDayStyle BackColor="#CCCCCC" ForeColor="Black" />
									<OtherMonthDayStyle ForeColor="#808080" />
									<NextPrevStyle VerticalAlign="Bottom" />
									<DayHeaderStyle BackColor="#CCCCCC" Font-Bold="True" Font-Size="7pt" />
									<TitleStyle BackColor="#999999" BorderColor="Black" Font-Bold="True" />
								</asp:Calendar>
								<asp:Calendar runat="server" id="_toDate">
									<SelectedDayStyle BackColor="#666666" Font-Bold="True" ForeColor="White" />
									<SelectorStyle BackColor="#CCCCCC" />
									<WeekendDayStyle BackColor="#FFFFCC" />
									<TodayDayStyle BackColor="#CCCCCC" ForeColor="Black" />
									<OtherMonthDayStyle ForeColor="#808080" />
									<NextPrevStyle VerticalAlign="Bottom" />
									<DayHeaderStyle BackColor="#CCCCCC" Font-Bold="True" Font-Size="7pt" />
									<TitleStyle BackColor="#999999" BorderColor="Black" Font-Bold="True" />
								</asp:Calendar>
							</ContentTemplate>
						</asp:UpdatePanel>
                         <br />
                    <asp:Button runat="server" ID="_editBtn" Text="Edit" Font-Bold="true" 
                         Width="126px" Height="27px" OnClientClick="editQuery()" 
                        Enabled="False"/>
                         <br />
                    <asp:TextBox ID="_query" runat="server"
                        Height="22px" Width="939px" style="display: none"></asp:TextBox>
                        
    </div>
    <p>
				    
					<asp:Button runat="server" ID="_submit" Text="Export To Excel" Font-Bold="true" 
                         Width="126px" Height="27px" onclick="_submit_Click" />
					</p>
					<br />
					<h3 style="color: Green">
					<asp:Label runat="server" ID="_errorMsg" Visible="false"/>
					</h3>
    </form>
</body>
</html>
