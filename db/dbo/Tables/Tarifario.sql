-- =====================================================
-- Object:  Table [dbo].[Tarifario]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Tarifario] (
    [NombreServicio] [varchar](50) NOT NULL,
    [NumeroTicket] [int] NOT NULL,
    [FechaCreacion] [datetime] NOT NULL,
	
    CONSTRAINT PK_Tarifario PRIMARY KEY CLUSTERED ([NombreServicio] ASC)
) 
ON [PRIMARY];
