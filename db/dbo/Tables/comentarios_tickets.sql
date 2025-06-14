-- =====================================================
-- Object:  Table [dbo].[comentarios_tickets]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[comentarios_tickets] (
    [ID] [int] IDENTITY(1,1) NOT NULL,
	[TicketID] [int] NOT NULL,
	[UsuarioID] [int] NOT NULL,
	[Comentario] [text] NOT NULL,
	[Fecha] [datetime] NULL DEFAULT GETDATE(),

    CONSTRAINT FK_comentarios_tickets_Tickets FOREIGN KEY (TicketID)
        REFERENCES [dbo].[Tickets] (ID),

    CONSTRAINT FK_comentarios_tickets_Usuarios FOREIGN KEY (UsuarioID)
        REFERENCES [dbo].[Usuarios] (ID)
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];