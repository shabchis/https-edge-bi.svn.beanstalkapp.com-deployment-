﻿<%@ Page MasterPageFile="~/default.Master" Language="C#" Inherits="Easynet.Edge.UI.WebPages.OrganicPage" Codebehind="Organic.aspx.cs" EnableEventValidation="false" %>

<%@ Register Assembly="ZedGraph.Web" Namespace="ZedGraph.Web" TagPrefix="zed" %>
<%@ Import Namespace="System.Data.SqlClient" %>
<%@ Import Namespace="Easynet.Edge.Core.Configuration" %>
<%@ Import Namespace="Easynet.Edge.Core.Data" %>

<asp:Content ContentPlaceHolderID="headPlaceHolder" runat="server">
</asp:Content>

<asp:Content ContentPlaceHolderID="ScriptPlaceHolder" runat="server">
	<script type="text/javascript">
		Sys.WebForms.PageRequestManager.getInstance().add_endRequest(pageLoad);

		function pageLoad()
		{
			$get('<%= _dateSelector.ClientID %>').onchange = UpdateCompareDate;
		}

		function UpdateCompareDate()
		{
			var dateSelector = $get('<%= _dateSelector.ClientID %>');
			var compareSelector = $get('<%= _compareSelector.ClientID %>');
			var targetSelection = dateSelector.length - 1;
			if (dateSelector.selectedIndex < dateSelector.length - 1)
				targetSelection = dateSelector.selectedIndex + 1;
			compareSelector.selectedIndex = targetSelection;
		}

		function $get(id)
		{
			return document.getElementById(id);
		}
		function confirmKwByTime()
		{
			if (confirm("This operation might take a few minutes. Proceed anyway? "))
			{
				document.getElementById('_processing').innerHTML = "processing...";
				return true;
			}
			else
			{
				document.getElementById('_processing').innerHTML = "";
				return false;
			}
		}
					
	</script>
</asp:Content>

<asp:Content runat="server" ContentPlaceHolderID="SelectorsPlaceHolder">
	<div class="selector">
		<div class="label">Profile</div>
		<div class="control">
			<asp:DropDownList runat="server" id="_profileSelector"  OnSelectedIndexChanged="_profileSelector_SelectedIndexChanged" AutoPostBack="true" />
		</div>
	</div>
	
	<asp:UpdatePanel ChildrenAsTriggers="true" runat="server">
		<Triggers>
			<asp:AsyncPostBackTrigger ControlID="_profileSelector" EventName="SelectedIndexChanged"/>
		</Triggers>
		
		<ContentTemplate>
			<div class="selector">
				<div class="label">Sample date</div>
				<div class="control">
					<asp:DropDownList runat="server" id="_dateSelector" />	
				</div>
			</div>
			
			<div class="selector">
				<div class="label">Compare with</div>
				<div class="control">
					<asp:DropDownList runat="server" id="_compareSelector" />	
				</div>
			</div>					
		</ContentTemplate>
	</asp:UpdatePanel>
	
	<asp:Button runat="server" ID="_submit" Text="Go"/>
						
		<asp:Button runat="server" ID="_export" Text="Export" />
		<asp:Button runat="server" ID="_exportAll" Text="Export all"/>
		<asp:Button runat="server" ID="_exportAllByTime" Text="Export Kw By Time" OnClientClick="return confirmKwByTime()"/>
        
		<asp:Label runat="server" ID="_failureMsg" Visible="false"/>
        <asp:Label ID="_warning" runat="server" />
	    <asp:Label ID="_processing" runat="server" />
	
</asp:Content>


<asp:Content ContentPlaceHolderID="ResultsPlaceHolder" runat="server">

	<asp:Repeater runat="server" ID="_profileSearchEngineRepeater">
		<HeaderTemplate>
			<h1><%# _profileName %></h1>
		</HeaderTemplate>
		<ItemTemplate>
			<h2><%# ((System.Data.DataTable)Container.DataItem).TableName  %></h2>
			<asp:DataGrid runat="server" ID="dataGrid"
				DataSource="<%# Container.DataItem %>"
				EnableViewState="false"
				CellPadding="4"
				ForeColor="#333333" 
				GridLines="Both"
				BorderColor="Silver"
				Width="<%# Unit.Percentage(100) %>"
			>
				<HeaderStyle BackColor="#1C5E55" Font-Bold="True" ForeColor="White" />
				<AlternatingItemStyle BackColor="White" />
				<ItemStyle BackColor="#E3EAEB" VerticalAlign="Top" HorizontalAlign="Left"/>
			</asp:DataGrid>
		</ItemTemplate>
	</asp:Repeater>
	

	<%-- ---------------------------------------------------------------------- --%>
	<%-- Templates --%>
	<asp:PlaceHolder runat="server" Visible="false" ID="_template_Keyword">
		<table width="100%">
			<tr>
				<td>
					<asp:PlaceHolder runat="server" Visible="<%# Output["link"] != null %>">
						<a href='<%# Output["link"] %>' target='_blank'><i><%# Output["keyword"]%></i></a>
					</asp:PlaceHolder>
					<asp:PlaceHolder runat="server" Visible="<%# Output["link"] == null %>">
						<i><%# Output["keyword"]%></i>
					</asp:PlaceHolder>
				</td>
				<td>
					<asp:PlaceHolder runat="server" Visible="<%# !Reader.IsDBNull("Rank") %>">
						<a href="">
							<zed:ZedGraphWeb runat="server" Width="105" Height="40"/>
						</a>
					</asp:PlaceHolder>
				</td>
			</tr>
		</table>
	</asp:PlaceHolder>
	
	<asp:PlaceHolder runat="server" Visible="false" ID="_template_Rank">
		<asp:Repeater runat="server" Visible="<% RowValues.IsClient %>">
			<HeaderTemplate>
				<table cellpadding='1'>
			</HeaderTemplate>
			<ItemTemplate>
				<tr>
					<td><b><%# RowValues.Rank %></b></td>
					<td style='width: 30px'>
						<asp:PlaceHolder runat="server" Visible="<%# RowValues.RankDiff == 0 %>">
							&nbsp;
						</asp:PlaceHolder>
						<asp:PlaceHolder runat="server" Visible="<%# RowValues.RankDiff > 0 %>">
							<span style='color: green'>(+<%# RowValues.RankDiff %>)</span>
						</asp:PlaceHolder>
						<asp:PlaceHolder runat="server" Visible="<%# RowValues.RankDiff < 0 %>">
							<span style='color: red'>(<%# RowValues.RankDiff %>)</span>
						</asp:PlaceHolder>
					</td>
					<td>
						<a href='<%# Server.HtmlEncode(RowValues.Url) %>' target='_blank' title='<%# Server.HtmlEncode(RowValues.Title) %>'
							><%# Server.HtmlEncode(RowValues.Url.Length <= 40 ? RowValues.Url : RowValues.Url.Substring(0, 40) + "...")%></a>
					</td>
				</tr>
			</ItemTemplate>
			<FooterTemplate>
				</table>
			</FooterTemplate>
		</asp:Repeater>
		
		<asp:Repeater runat="server" Visible="<% !RowValues.IsClient %>">
			<ItemTemplate>
				<a href='{2}' target='_blank' title='{3} || {4} || {5}'>{0}</a>
				<asp:PlaceHolder  runat="server" Visible="<%# RowValues.RankDiff != 0 %>">
					<span style='color: #999; font-size: 8px'>(<%# RowValues.RankDiff %>)</span>
				</asp:PlaceHolder>
			</ItemTemplate>
		</asp:Repeater>
		
		<asp:PlaceHolder runat="server" Visible="false">
			<span style='color: #999'>-</span>
		</asp:PlaceHolder>
	</asp:PlaceHolder>
	<%-- ---------------------------------------------------------------------- --%>

	<asp:PlaceHolder ID="GraphsHolder" runat="server" Visible="false"></asp:PlaceHolder>
	
</asp:Content>